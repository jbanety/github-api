<?php
/**
 * @copyright  Copyright (C) 2016 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Pages;
use Joomla\Registry\Registry;

/**
 * Test class for Pages.
 *
 * @since  1.0
 */
class PagesTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    Registry  Options for the GitHub object.
	 * @since  11.4
	 */
	protected $options;

	/**
	 * @var    \PHPUnit_Framework_MockObject_MockObject  Mock client object.
	 * @since  11.4
	 */
	protected $client;

	/**
	 * @var    \Joomla\Http\Response  Mock response object.
	 * @since  12.3
	 */
	protected $response;

	/**
	 * @var Pages
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  12.3
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  12.3
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @since   1.0
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options  = new Registry;

		$this->client = $this->getMockBuilder('\\Joomla\\Github\\Http')
			->setMethods(array('get', 'post', 'delete', 'patch', 'put'))
			->getMock();

		$this->response = $this->getMockBuilder('\\Joomla\\Http\\Response')->getMock();

		$this->object = new Pages($this->options, $this->client);
	}

	/**
	 * Tests the GetInfo method.
	 *
	 * @return  void
	 */
	public function testGetInfo()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{owner}/{repo}/pages')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getInfo('{owner}', '{repo}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetList method.
	 *
	 * @return  void
	 */
	public function testGetList()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{owner}/{repo}/pages/builds')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getList('{owner}', '{repo}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the GetLatest method.
	 *
	 * @return  void
	 */
	public function testGetLatest()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/{owner}/{repo}/pages/builds/latest')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getLatest('{owner}', '{repo}'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}
}
