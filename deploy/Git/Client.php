<?php

/**
 * @todo PHPDOC
 * @author Ben Tadiar <ben@handcraftedbyben.co.uk>
 */
namespace Git;
class Client
{
	/**
	 * Path to the directory containing the Git binary
	 * @todo Path is only required for Windows, put in check
	 * @var string
	 */
	private $path = ':/usr/bin';
	
	/**
	 * Add Git to the PATH environment variable
	 * @return void
	 */
	public function __construct()
	{
		putenv('PATH=' . getenv('PATH') . $this->path);
	}
	
	/**
	 * Clone a repository
	 * @param string $repo The GitHub repository
	 * @param ull|string $dir The directory to clone into
	 */
	public function cloneRepo($repo, $dir = null)
	{
		// If no directory is specified, use the
		// repository name, less the .git extension
		if($dir === null){
			$start = strrpos($repo, '/') + 1;
			$dir = substr($repo, $start, -4);
		}
		
		$cmd = "git clone $repo $dir 2>&1";
		$output = $this->call($cmd);
		return $dir;
	}
	
	/**
	 * List all local branches
	 * @return array
	 */
	public function branches($repo)
	{
		chdir($repo);
		$branches = array();
		foreach($this->call('git branch -a') as $branch){
			if($branch[0] == '*') $branch = substr($branch, 2);
			$parts = explode('/', $branch);
			$branch = end($parts);
			$branches[] = trim($branch);
		}
		return array_unique($branches);
	}

    /**
     * Checkout branch
     *
     * @access public
     * @param $branch
     * @return string
     */
    public function checkout($branch)
	{
		if($branch != 'master') $branch = '-t ' . $branch;
		$cmd = "git checkout $branch 2>&1";
		$output = $this->call($cmd);
		return $output;
	}
	
	public function pull($branch)
	{
		$cmd = "git pull 2>&1";
		$output = $this->call($cmd);
		return $output;
	}

    /**
     * Execute the command
     *
     * @return string
     * @param $cmd
     * @return array
     * @throws ClientException
     */
    private function call($cmd)
	{
		exec($cmd, $output, $status);
		if($status != 0 && $output){
            throw new ClientException($status.' : '.$this->_array2String($output));
		}
		return $output;
	}

    /**
     * Convert array to string
     *
     * @access private
     * @param array $arr
     * @param string $delimiter
     * @return string
     */
    private function _array2String(array $arr, $delimiter = '\n')
    {
        return implode($delimiter, $arr);
    }
}
class ClientException extends \Exception{}
