<?php

namespace WowPkgmeta;

abstract class Dependency {
    protected $targetDirectory;
    protected $url;
    protected $tag;

    public function __construct(string $targetDirectory, array $details)
    {
        $this->targetDirectory = $targetDirectory;
        $this->url = $details['url'] ?? null;
        $this->tag = $details['tag'] ?? null;
    }
}