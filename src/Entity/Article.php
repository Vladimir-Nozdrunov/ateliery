<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("article")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="title")
     */
    protected $title;

    /**
     * @ORM\Column(type="date", name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="string", name="intro_text", nullable=true)
     */
    protected $introText;

    /**
     * @ORM\Column(type="string", name="content", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", name="preview_img", nullable=true)
     */
    protected $previewImg;

    /**
     * @ORM\Column(type="boolean", name="is_published")
     */
    protected $isPublished;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getIntroText()
    {
        return $this->introText;
    }

    /**
     * @param mixed $introText
     */
    public function setIntroText($introText): void
    {
        $this->introText = $introText;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $text
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPreviewImg()
    {
        return $this->previewImg;
    }

    /**
     * @param mixed $previewImg
     */
    public function setPreviewImg($previewImg): void
    {
        $this->previewImg = $previewImg;
    }

    /**
     * @return mixed
     */
    public function getisPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }



}