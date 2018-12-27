<?php

namespace Wruczek\TSWebsite\Utils;

use function mt_rand;
use function var_dump;
use Wruczek\TSWebsite\Config;

/**
 * Class TeamSpeakUtils
 * @package Wruczek\TSWebsite\Utils
 * @author Wruczek 2017
 */
class TeamSpeakUtils {

    use SingletonTait;

    protected $configUtils;
    protected $tsNodeHost;
    protected $tsNodeServer;
    protected $exceptionsList = [];

    private function __construct() {
        $this->configUtils = Config::i();
    }

    /**
     * Returns TeamSpeak3_Node_Host object created using
     * data from config database
     * @return \TeamSpeak3_Node_Host
     */
    public function getTSNodeHost() {
        if($this->tsNodeHost === null) {
            $hostname = $this->configUtils->getValue("query_hostname");
            $queryport = $this->configUtils->getValue("query_port");
            $username = $this->configUtils->getValue("query_username");
            $password = $this->configUtils->getValue("query_password");

            try {
                $tsNodeHost = \TeamSpeak3::factory("serverquery://$hostname:$queryport/?timeout=3");
                $tsNodeHost->login($username, $password);
                $this->tsNodeHost = $tsNodeHost;
            } catch (\Exception $e) {
                $this->addExceptionToExceptionsList($e);
            }
        }

        return $this->tsNodeHost;
    }

    /**
     * Returns TeamSpeak3_Node_Server object created
     * using getTSNodeHost() method.
     * @return \TeamSpeak3_Node_Server
     */
    public function getTSNodeServer() {
        // Don't continue if TSNodeHost is NULL (not working / not initialised)
        if($this->tsNodeServer === null && $this->getTSNodeHost()) {
            $port = $this->configUtils->getValue("tsserver_port");

            try {
                $this->tsNodeServer = $this->getTSNodeHost()->serverGetByPort($port);

                $newNickname = Config::get("query_nickname");

                // if available, set the query nickname. add random numbers to the end, so
                // the bot will work even with a user/query of the same nickname online
                if (isset($newNickname)) {
                    // try 5 times to change the nickname if the previous is already in use
                    for($i = 0; $i < 5; $i++) {
                        try {
                            $this->tsNodeServer->selfUpdate(["client_nickname" => $newNickname]);
                            break; // success - we have set the nickname
                        } catch (\TeamSpeak3_Exception $e) {
                            // error nickname in use
                            if ($e->getCode() === 513) {
                                // add something random to the name and try again
                                $newNickname .= mt_rand(0, 9);
                            } else {
                                // if thats other error than nickname in use, re-throw it
                                throw $e;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->addExceptionToExceptionsList($e);
            }
        }

        return $this->tsNodeServer;
    }

    /**
     * Tries to download file from the TS3 server. It might be an actual file,
     * icon or avatar. Returns downloaded data. Might throw exceptions when filetransfer fails.
     * @param $filename
     * @param int $cid Channel Id (defaults to 0 - server)
     * @param string $cpw Channel password (defaults to empty)
     * @return mixed
     * @throws \TeamSpeak3_Adapter_ServerQuery_Exception
     */
    public function ftDownloadFile($filename, $cid = 0, $cpw = "") {
        $dl = $this->getTSNodeServer()->transferInitDownload(mt_rand(0x0000, 0xFFFF), $cid, $filename, $cpw);
        $host = (false !== strpos($dl["host"], ":") ? "[" . $dl["host"] . "]" : $dl["host"]);
        $filetransfer = \TeamSpeak3::factory("filetransfer://$host:" . $dl["port"]);

        return $filetransfer->download($dl["ftkey"], $dl["size"]);
    }

    /**
     * Resets current connection, forces to reconnect to the TeamSpeak server
     * next time you call getTSNodeHost or getTSNodeServer
     */
    public function reset() {
        $this->tsNodeHost = null;
        $this->tsNodeServer = null;
    }

    /**
     * Checks TeamSpeak server connection
     * Warning: it will connect to the TeamSpeak server to check the status.
     *          Use it just before accessing the server, preferably after checking cache.
     * @return bool true if TeamSpeak connection succeeded, false otherwise
     */
    public function checkTSConnection() {
        return $this->getTSNodeHost() !== null
            && $this->getTSNodeServer() !== null
            && empty($this->getExceptionsList());
    }

    /**
     * Adds exception to the exceptions list
     * @param \Exception $exception
     */
    public function addExceptionToExceptionsList($exception) {
        $this->exceptionsList[$exception->getCode()] = $exception;
    }

    /**
     * Returns array filled with connection exceptions collected
     * when calling getTSNodeServer(), getTSNodeServer() and other methods
     * @return array Array filled with exceptions. Empty if no exceptions where thrown.
     */
    public function getExceptionsList() {
        return $this->exceptionsList;
    }
}
