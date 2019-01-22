<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Utils\FilenameExtractor;

class FilenameExtractorTest extends TestCase
{
    public function testExtract()
    {
        $this->assertEquals(FilenameExtractor::extract('http://www.google.co.in/intl/en_com/images/srpr/logo1w.png', 1), '1_logo1w.png');
        $this->assertEquals(FilenameExtractor::extract('http://www.google.co.in/', 2), '2_www.google.co.in');
        $this->assertEquals(FilenameExtractor::extract('http://www.google.co.in', 3), '3_www.google.co.in');
        $this->assertEquals(FilenameExtractor::extract('http://www.google.co.in/somepage', 4), '4_somepage.html');
        $this->assertEquals(FilenameExtractor::extract('http://www.google.co.in/anotherpage/', 5), '5_anotherpage.html');
        $this->assertEquals(FilenameExtractor::extract('http://www.example.com/anotherpage/someclip.avi', 6), '6_someclip.avi');
    }

    public function testClear()
    {
        $this->assertEquals(FilenameExtractor::clear('1_logo1w.png', 1), 'logo1w.png');
        $this->assertEquals(FilenameExtractor::clear('2_www.google.co.in', 2), 'www.google.co.in');
    }
}
