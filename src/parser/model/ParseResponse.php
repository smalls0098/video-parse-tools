<?php


namespace smalls\videoParseTools\parser\model;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class ParseResponse
{

    private $originalUrl = "";

    private $userName = "";

    private $userHeadImg = "";

    private $description = "";

    private $videoCover = "";

    private $videoUrl = "";

    /**
     * ParseResponse constructor.
     * @param string $originalUrl
     * @param string $userName
     * @param string $userHeadImg
     * @param string $description
     * @param string $videoCover
     * @param string $videoUrl
     */
    public function __construct(string $originalUrl, string $userName, string $userHeadImg, string $description, string $videoCover, string $videoUrl)
    {
        $this->originalUrl = $originalUrl;
        $this->userName = $userName;
        $this->userHeadImg = $userHeadImg;
        $this->description = $description;
        $this->videoCover = $videoCover;
        $this->videoUrl = $videoUrl;
    }


    /**
     * @return string
     */
    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    /**
     * @param string $originalUrl
     */
    public function setOriginalUrl(string $originalUrl)
    {
        $this->originalUrl = $originalUrl;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserHeadImg(): string
    {
        return $this->userHeadImg;
    }

    /**
     * @param string $userHeadImg
     */
    public function setUserHeadImg(string $userHeadImg)
    {
        $this->userHeadImg = $userHeadImg;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getVideoCover(): string
    {
        return $this->videoCover;
    }

    /**
     * @param string $videoCover
     */
    public function setVideoCover(string $videoCover)
    {
        $this->videoCover = $videoCover;
    }

    /**
     * @return string
     */
    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     */
    public function setVideoUrl(string $videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }



}