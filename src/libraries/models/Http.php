<?php
/**
 * Http model.
 *
 * This handles outgoing HTTP interactions.
 * @author Jaisen Mathai <jaisen@jmathai.com>
 */
class Http extends BaseModel
{
  /*
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
  }

  public function fireAndForget($url, $method = 'GET', $params = null)
  {
    $url = escapeshellarg($url);
    $method = escapeshellarg($method);
    $paramsAsString = '';
    if(!empty($params) && is_array($params))
    {
      foreach($params as $key => $value)
        $paramsAsString .= sprintf("-F %s ", escapeshellarg("{$key}={$value}"));
    }
    $command = sprintf("curl -X %s %s %s > /dev/null 2> /dev/null &", $method, $paramsAsString, $url);
    $this->logger->info($command);
    exec($command);
  }
}
