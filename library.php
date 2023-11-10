<?php

class Library {
    private $books = [];

    public function addBook($book) {
        $this->books[] = $book;
    }

    public function getBooks() {
        return $this->books;
    }

    public function deleteBook($bookId) {
        foreach ($this->books as $key => $book) {
            if ($book->id == $bookId) {
                unset($this->books[$key]);
                break;
            }
        }
    }
}

?>
