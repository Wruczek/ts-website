<?php

namespace Wruczek\TSWebsite\News;

use function mb_substr;
use function time;
use Wruczek\TSWebsite\Utils\DatabaseUtils;

/**
 * Class DefaultNewsStore.
 * Reads news from the database, they might be added via the admin panel.
 * @package Wruczek\TSWebsite\News
 */
class DefaultNewsStore implements INewsStore {

    private $db;
    private $newsTable = "news";

    public function __construct() {
        $this->db = DatabaseUtils::i()->getDb();
    }

    public function getNewsList($limit, $offset = null) {
        if ($limit !== null && !\is_int($limit)) {
            throw new \InvalidArgumentException("limit must be an integer");
        }

        if ($offset !== null && !\is_int($offset)) {
            throw new \InvalidArgumentException("offset must be an integer");
        }

        $options = []; // Medoo: [$offset, $limit]

        // If we have both limit and offset
        if ($limit !== null && $offset !== null) {
            $options = [$offset, $limit];
        } else if ($limit !== null) { // if we have only limit
            $options = $limit;
        }

        $data = $this->db->select($this->newsTable, "*", [
            "ORDER" => ["added" => "DESC"],
            "LIMIT" => $options
        ]);

        $newsList = [];

        foreach ($data as $row) {
            $newsId = $row["newsid"];

            $newsList[$newsId] = [
                "newsId" => $newsId,
                "title" => $row["title"],
                // There is no separate news pages for now, so we show the entire content as the description
//                "description" => mb_substr($row["content"], 0, 200),
                "description" => $row["content"],
                "added" => $row["added"],
                "edited" => $row["edited"],
                // "link" => "news.php?id=$newsId",
                "external" => false,
            ];
        }

        return $newsList;
    }

    public function getNews($newsId) {
        return $this->db->get($this->newsTable, "*", [
            "newsId" => $newsId,
        ]);
    }

    public function getNewsCount() {
        return $this->db->count($this->newsTable);
    }

    public function addNews($title, $content, $addDate = null, $editDate = null) {
        if ($addDate === null) {
            $addDate = time();
        }

        $this->db->insert($this->newsTable, [
            "title" => $title,
            "added" => $addDate,
            "edited" => $editDate,
            "content" => $content,
        ]);

        return $this->db->id();
    }

    public function editNews($newsId, $title = null, $content = null, $addDate = null, $editDate = null) {
        $data = [];

        if ($title !== null) $data["title"] = $title;
        if ($content !== null) $data["content"] = $content;
        if ($addDate !== null) $data["added"] = $addDate;
        if ($editDate !== null) $data["edited"] = $editDate;

        $update = $this->db->update($this->newsTable, $data, [
            "newsId" => $newsId
        ]);

        return $update->rowCount() !== 0;
    }
}
