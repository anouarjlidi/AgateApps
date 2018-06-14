<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Entity\Traits;

use CorahnRin\Entity\Books;
use Doctrine\ORM\Mapping as ORM;

trait HasBook
{
    /**
     * @var Books
     * @ORM\ManyToOne(targetEntity="Books")
     * @ORM\JoinColumn(name="book_id", nullable=true)
     */
    protected $book;

    public function setBook(Books $book = null): self
    {
        $this->book = $book;

        return $this;
    }

    public function getBook(): ?Books
    {
        return $this->book;
    }
}
