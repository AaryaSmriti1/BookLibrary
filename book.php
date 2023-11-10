<?php

class Book {
    public $id;
    public $title;
    public $author;
    public $isbn;
    public $coverUrl;

    public function __construct($id, $title, $author, $isbn, $coverUrl) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->coverUrl = $coverUrl;
    }
}

?>
