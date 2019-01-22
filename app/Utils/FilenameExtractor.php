<?php

namespace App\Utils;

class FilenameExtractor
{
    public static function extract($url, $id)
    {
        $path_parts = pathinfo($url);
        $extension = $path_parts['extension'] ?? 'html';
        $filename = $path_parts['filename'];
        return $id . '_' . $filename . '.' . $extension;
    }

    public static function clear($filename, $id)
    {
        return str_replace($id . '_', '', $filename);
    }
}