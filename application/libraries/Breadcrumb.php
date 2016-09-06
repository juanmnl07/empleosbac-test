<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Breadcrumb for CodeIgniter
 */
class Breadcrumb
{
  public $link_type = ' / ';
  public $breadcrumb = array();
  public $output = '';

  /**
   * completely remove all previous generation data
   *
   * @return bool
   */
  public function clear()
  {
    $props = array('breadcrumb', 'output');

    foreach ($props as $val)
    {
      $this->$val = null;
    }

    return true;
  }

  /**
   * add a "crumb" - new link
   *
   * @param string $title displayed name of the link
   * @param bool $url place to go to
   * @return bool
   */
  public function add($title, $url = false)
  {

    $this->breadcrumb[] =
      array(
      'title' => $title,
      'url' => $url
      );

    return true;
  }

  /**
   * the delimiter between links
   *
   * @param string $new_link delimiter value
   * @return bool
   */
  public function change_link($new_link)
  {
    $this->link_type = ' ' . $new_link . ' ';
    return true;
  }

  /**
   * render an output
   *
   * @return string
   */
  public function show()
  {
    $counter = 0;

    foreach ($this->breadcrumb as $val)
    {
      if ($counter > 0)
      {
        $this->output .= $this->link_type;
      }

      if ($val['url'])
      {
        $this->output .= '<a href="' . $val['url'] . '">' . $val['title'] . '</a>';
      }
      else
      {
        $this->output .= $val['title'];
      }

      $counter++;
    }

    return $this->output;
  }
}
