<?php

/**
 * Handlers are used to parse and serialize payloads for specific
 * mime types.  You can register a custom handler via the register
 * method.  You can also override a default parser in this way.
 */
namespace Httpful\Handlers;

class MimeHandlerAdapter
{
    public function __construct(array $args = array())
    {
        $this->init($args);
    }
    /**
     * Initial setup of
     * @param array $args
     */
    public function init(array $args)
    {
    }
    /**
     * @param string $body
     * @return mixed
     */
    public function parse($body)
    {
        return $body;
    }
    /**
     * @param mixed $payload
     * @return string
     */
    function serialize($payload)
    {
        return (string) $payload;
    }
    protected function stripBom($body)
    {
        if (substr($body, 0, 3) === "ï»¿") {
            // UTF-8
            $body = substr($body, 3);
        } else {
            if (substr($body, 0, 4) === "ÿþ\0\0" || substr($body, 0, 4) === "\0\0þÿ") {
                // UTF-32
                $body = substr($body, 4);
            } else {
                if (substr($body, 0, 2) === "ÿþ" || substr($body, 0, 2) === "þÿ") {
                    // UTF-16
                    $body = substr($body, 2);
                }
            }
        }
        return $body;
    }
}

?>