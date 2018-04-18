<?php

/**
 * jDelta PrettyJson library
 * 
 * https://jdelta.github.io/pretty-json
 * Version 1.0
 * 
 * Copyright 2018, Jaime Cruz
 * Released under the MIT license
 */

namespace jDelta;

class PrettyJson {

    const TYPE_VALUE = 1;
    const TYPE_ARRAY = 2;
    const TYPE_OBJECT = 3;
    const DISTRIBUTION_HORIZONTAL = 1;
    const DISTRIBUTION_VERTICAL = 2;
    const INDENT_SPACES = 4;

    /**
     * Returns a new JSON string pretty nice formatted for printing.
     * 
     * @param string $json the JSON input.
     * @param boolean $stripSlashes set to **false** to avoid strip slashes
     * @return string the resulting JSON string.
     */
    public static function getPrettyPrint($json, $stripSlashes = true) {
        $data = json_decode($json, true);
        $output = self::format($data, null, 0);
        if ($stripSlashes) {
            $output = stripcslashes($output);
        }
        return $output;
    }

    /**
     * Transforms an array to a JSON string formated in pretty format.
     * @param array $data
     * @param string $dataKey
     * @param int $depth
     * @return string 
     */
    private static function format($data, $dataKey = null, $depth = 0) {
        if (!is_array($data)) {
            $block = json_encode($data);
            return self::encodeBlock($block, $dataKey);
        }
        $ln = count($data);
        $isArray = self::isJsonArray($data);
        if ($ln == 0) {
            return self::encodeBlock('[]', $dataKey);
        }
        $innerBlocks = [];
        foreach ($data as $key => $item) {
            if ($isArray) {
                $innerBlocks[] = self::format($item, null, $depth + 1);
            } else {
                $innerBlocks[] = self::format($item, $key, $depth + 1);
            }
        }
        return self::joinBlocks($data, $innerBlocks, $dataKey, $depth + 1);
    }

    /**
     * Joins block of elements producing an array or an object.
     * 
     * @param array $data the data where the blocks come from
     * @param array $blocks the blocks to be joined
     * @param string $dataKey the property name of th block
     * @param int $depth the block depth
     * @return int
     */
    private static function joinBlocks($data, $blocks, $dataKey, $depth) {
        $isArray = self::isJsonArray($data);
        $baseSpace = self::getIndent($depth - 1);
        $innerSpace = self::getIndent($depth);

        $joinDir = self::getJoiningDirection($data);

        if ($joinDir == self::DISTRIBUTION_VERTICAL) {
            $block = "\n$innerSpace" . implode(",\n$innerSpace", $blocks) . "\n$baseSpace";
        } else {
            $block = implode(", ", $blocks);
        }

        if ($isArray) {
            return self::encodeBlock('[' . $block . ']', $dataKey);
        }
        return self::encodeBlock('{' . $block . '}', $dataKey);
    }

    /**
     * Decides how the blocks are going to be shown horizontal or vertical.
     * 
     * @param mixed $data
     * @return int
     */
    private static function getJoiningDirection($data) {
        foreach ($data as $item) {
            $itemType = self::getItemType($item);
            if ($itemType == self::TYPE_OBJECT) {
                return self::DISTRIBUTION_VERTICAL;
            }
            // check sub item
            if ($itemType == self::TYPE_ARRAY) {
                return self::getJoiningDirection($item);
            }
        }
        return self::DISTRIBUTION_HORIZONTAL;
    }

    /**
     * Encodes a block
     * 
     * @param string $block
     * @param string $key
     * @return string
     */
    private static function encodeBlock($block, $key = null) {
        if (is_null($key)) {
            return $block;
        } else {
            return '"' . $key . '": ' . $block;
        }
    }

    /**
     * Checks if an array is the equivalent of an JSON array
     * @param array $data
     * @return boolean
     */
    private static function isJsonArray($data) {
        $keys = array_keys($data);
        foreach ($keys as $key) {
            if (!is_int($key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns the type on item
     *  
     * @param mixed $item
     * @return int
     */
    private static function getItemType($item) {
        if (is_array($item)) {
            if (self::isJsonArray($item)) {
                return self::TYPE_ARRAY;
            }
            return self::TYPE_OBJECT;
        }
        return self::TYPE_VALUE;
    }

    /**
     * Returns the spaces that are placed at the begging of a block
     * 
     * @param int $depth the block depth
     * @return string
     */
    private static function getIndent($depth) {
        return str_pad('', self::INDENT_SPACES * $depth);
    }

}
