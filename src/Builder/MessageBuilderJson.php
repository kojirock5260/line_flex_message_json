<?php


namespace Kojirock5260\SimpleLineFlexMessage\Builder;


interface MessageBuilderJson
{
    /**
     * @return string
     */
    public function getAltText();

    /**
     * @return string
     */
    public function getContents();
}