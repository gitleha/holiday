<?php
/*
 * CalFileParser
 *
 * Parser for iCal and vCal files. Reads event information and
 * outputs data into an Array or JSON
 *
 * @author Michael Mottola <mikemottola@gmail.com>
 * @license MIT
 * @version 1.0
 *
 */
namespace Aqualeha\AppBundle\Services;

use DateTime;

/**
 * Class CalFileParser
 *
 * @package Aqualeha\AppBundle\Services
 */
class CalFileParser
{
    /**
     * @var string $basePath
     */
    private $basePath = './';

    /**
     * @var string $fileName
     */
    private $fileName = '';

    /**
     * @var string $output
     */
    private $output = 'array';

    /**
     * @var array $DTfields
     */
    private $DTfields = array('dtstart', 'dtend', 'dtstamp', 'created', 'last-modified');

    /**
     * @var null $timezone
     */
    private $timezone = null;

    /**
     * Init CalFileParser
     */
    public function __construct()
    {
        $this->defaultOuput = $this->output;
    }

    /**
     * @param string $path
     */
    public function setBasePath($path)
    {
        if (isset($path)) {
            $this->basePath = $path;
        }
    }

    /**
     * @param string $filename
     */
    public function setFileName($filename)
    {
        if (!empty($filename)) {
            $this->fileName = $filename;
        }
    }

    /**
     * @param string $output
     */
    public function setOutput($output)
    {
        if (!empty($output)) {
            $this->output = $output;
        }
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * Read File
     *
     * @param string $file
     *
     * @return string
     *
     * @example
     *  readFile('schedule.vcal')
     *  readFile('../2011-08/'schedule.vcal');
     *  readFile('http://michaelencode.com/example.vcal');
     */
    public function readFile($file = '')
    {
        if (empty($file)) {
            $file = $this->fileName;
        }
        // check to see if file path is a url
        if (preg_match('/^(http|https):/', $file) === 1) {
            return $this->readRemoteFile($file);
        }

        //empty base path if file starts with forward-slash
        if (substr($file, 0, 1) === '/') {
            $this->setBasePath('');
        }

        if (!empty($file) && file_exists($this->basePath . $file)) {
            $fileContents = file_get_contents($this->basePath . $file);

            return $fileContents;
        } else {
            return false;
        }
    }
    /**
     * Read Remote File
     *
     * @param string $file
     *
     * @return bool|string
     */
    public function readRemoteFile($file)
    {
        if (!empty($file)) {
            $data = file_get_contents($file);
            if ($data !== false) {
                return $data;
            }
        }

        return false;
    }
    /**
     * Parse
     * Parses iCal or vCal file and returns data of a type that is specified
     *
     * @param string $file
     * @param string $output
     *
     * @return mixed|string
     */
    public function parse($file = '', $output = '')
    {
        $fileContents = $this->readFile($file);
        if ($fileContents === false) {
            return 'Error: File Could not be read';
        }
        if (empty($output)) {
            $output = $this->output;
        }
        if (empty($output)) {
            $output = $this->defaultOuput;
        }
        $eventsArr = array();
        // fetch timezone to create datetime object
        if (preg_match('/X-WR-TIMEZONE:(.+)/i', $fileContents, $timezone) === 1) {
            $date = new DateTime();
            $date->createFromFormat('e', trim($timezone[1]));
            if ($date !== false) {
                $this->timezone = $date->getTimezone();
            }
        }
        //put contains between start and end of VEVENT into array called $events
        preg_match_all('/(BEGIN:VEVENT.*?END:VEVENT)/si', $fileContents, $events);
        if (!empty($events)) {
            foreach ($events[0] as $eventStr) {
                //remove begin and end "tags"
                $eventStr = trim(str_replace(array('BEGIN:VEVENT', 'END:VEVENT'), '', $eventStr));
                //convert string of entire event into an array with elements containing string of 'key:value'
                $eventKeyPairs = $this->convertEventStringToArray($eventStr);
                //convert array of 'key:value' strings to an array of key => values
                $eventsArr[] = $this->convertKeyValueStrings($eventKeyPairs);
            }
        }
        $this->output = $this->defaultOuput;

        return $this->output($eventsArr, $output);
    }
    /**
     * Output
     * outputs data in the format specified
     *
     * @param mixed  $eventsArr
     *
     * @param string $output
     *
     * @return mixed
     */
    private function output($eventsArr, $output = 'array')
    {
        switch ($output) {
            case 'json' :
                return json_encode($eventsArr);
                break;
            default :
                return $eventsArr;
                break;
        }
    }
    /**
     * Convert event string to array
     * accepts a string of calendar event data and produces array of 'key:value' strings
     * See convertKeyValueStrings() to convert strings to
     *
     * @param string $eventStr
     *
     * @return array
     */
    private function convertEventStringToArray($eventStr = '')
    {
        if (!empty($eventStr)) {
            //replace new lines with a custom delimiter
            $eventStr = preg_replace("/[\r\n]/", "%%", $eventStr);
            if (strpos(substr($eventStr, 2), '%%') == '0') {
                //if this code is executed, then file consisted of one line causing previous tactic to fail
                $tmpPiece = explode(':', $eventStr);
                $numPieces = count($tmpPiece);
                $eventStr = '';
                foreach ($tmpPiece as $key => $itemStr) {
                    if ($key != ($numPieces -1) ) {
                        //split at spaces
                        $tmpPieces = preg_split('/\s/', $itemStr);
                        //get the last whole word in the string [item]
                        $lastWord = end($tmpPieces);
                        //adds delimiter to front and back of item string, and also between each new key
                        $itemStr = trim(str_replace(array($lastWord, ' %%'.$lastWord), array('%%'.$lastWord.':', '%%'.$lastWord), $itemStr));
                    }
                    //build the event string back together, piece by piece
                    $eventStr .= trim($itemStr);
                }
            }
            //perform some house cleaning just in case
            $eventStr = str_replace('%%%%', '%%', $eventStr);
            if (substr($eventStr, 0, 2) == '%%') {
                $eventStr = substr($eventStr, 2);
            }
            //break string into array elements at custom delimiter
            $return = explode('%%', $eventStr);
        } else {
            $return = array();
        }

        return $return;
    }
    /**
     * Parse Key Value String
     * accepts an array of strings in the format of 'key:value' and returns an array of keys and values
     *
     * @param array $eventKeyPairs
     *
     * @return array
     */
    private function convertKeyValueStrings($eventKeyPairs = array())
    {
        $event = array();
        if (!empty($eventKeyPairs)) {
            foreach ($eventKeyPairs as $line) {
                if (empty($line)) {
                    continue;
                }
                if ($line[0] == ' ') {
                    $event[$key] .= substr($line, 1);
                } else {
                    list($key, $value) = explode(':', $line, 2);
                    $key = strtolower(trim($key));
                    // autoconvert datetime fields to DateTime object
                    if (in_array($key, $this->DTfields)) {
                        $dtStr = str_replace(array('T', 'Z'), array('', ''), $value);
                        $format = 'Ymdhis';

                        $date = new DateTime();
                        $date->createFromFormat($format, $dtStr);

                        if ($date !== false) {
                            $value = $date;
                        }
                    }
                    $event[$key] = $value;
                }
            }
        }
        // unescape every element if string.
        return array_map(function($value) {
            return (is_string($value) ? stripcslashes($value) : $value);
        }, $event);
    }

    /**
     * @param int  $time
     * @param bool $inclTime
     *
     * @return bool|string
     */
    public function getIcalDate($time, $inclTime = true)
    {
        return $inclTime ? date('Ymd\THis', $time) : date('Ymd', $time);
    }
}