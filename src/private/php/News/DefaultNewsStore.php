<?php

namespace Wruczek\TSWebsite\News;

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

    public function getNewsList(int $limit, int $offset = null): array {
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

    public function getNews(int $newsId): ?array {
        return $this->db->get($this->newsTable, "*", [
            "newsId" => $newsId,
        ]);
    }

    public function getNewsCount(): int {
        return $this->db->count($this->newsTable);
    }

    public function addNews(string $title, string $content, ?int $addDate = null, ?int $editDate = null): int {
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

    public function editNews(int $newsId, string $title = null, string $content = null, ?int $addDate = null, ?int $editDate = null): bool {
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
