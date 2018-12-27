<?php

namespace Wruczek\TSWebsite\News;

interface INewsStore {

    /**
     * Returns array with news, sorted by the latest first. Format:
     * <code>
     * [
     *     $newsId = [
     *         "newsId" => int,
     *         "title" => "title of the news",
     *         "description" => "short description",
     *         "added" => int creation timestamp,
     *         "edited" => int last edit timestamp, null if never edited,
     *         "link" => "clicking on the news header will redirect here",
     *         "external" => true|false if true, the link will open in new tab
     *     ]
     * ]
     * </code>
     * @param int $limit Number of results to return
     * @param int $offset From where to start the list
     * @return array array with the news
     * @throws \Exception when we cannot get the news
     */
    public function getNewsList($limit, $offset = null);

    /**
     * Returns full information about this particular news
     * @param int $newsId
     * @return array|null array with the news details or null if news was not found
     */
    public function getNews($newsId);

    /**
     * Returns a number of news in the database
     * @return int
     */
    public function getNewsCount();

    /**
     * Adds a new news and return its new id
     * @param string $title
     * @param string $content
     * @param null|int $addDate if null, the implementation will use the current timestamp
     * @param null|int $editDate
     * @return int newsId of the inserted news
     */
    public function addNews($title, $content, $addDate = null, $editDate = null);

    /**
     * Edit the news selected by $newsId. All parameters are optional, and only the provided ones will be changed
     * @param int $newsId
     * @param string|null $title
     * @param string|null $content
     * @param int|null $addDate
     * @param int|null $editDate
     */
    public function editNews($newsId, $title = null, $content = null, $addDate = null, $editDate = null);

}
