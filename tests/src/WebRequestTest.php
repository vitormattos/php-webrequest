<?php

namespace ByJG\Util;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-07-14 at 08:40:35.
 */
class WebRequestTest extends \PHPUnit_Framework_TestCase
{
    const SERVER_TEST = 'http://xpto.us/webrequest-test/rest.php'; // LOCAL: 'http://localhost:8080/rest.php';

    /**
     * @var WebRequest
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new WebRequest(self::SERVER_TEST);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers ByJG\Util\WebRequest::setCredentials
     */
    public function testSetCredentials()
    {
        $this->object->setCredentials('user', 'pass');

        $this->assertEquals(CURLAUTH_BASIC, $this->object->getCurlOption(CURLOPT_HTTPAUTH));
        $this->assertEquals('user:pass', $this->object->getCurlOption(CURLOPT_USERPWD));
    }

    /**
     * @covers ByJG\Util\WebRequest::getReferer
     * @covers ByJG\Util\WebRequest::setReferer
     */
    public function testReferer()
    {
        $this->object->setReferer('http://example.com');
        $this->assertEquals('http://example.com', $this->object->getReferer());
    }

    /**
     * @covers ByJG\Util\WebRequest::getLastStatus
     */
    public function testGetLastStatus()
    {
        $this->object->get();
        $this->assertEquals(200, $this->object->getLastStatus());
    }

    /**
     * @covers ByJG\Util\WebRequest::getResponseHeader
     */
    public function testGetResponseHeader()
    {
        $this->object->get();

        $result = $this->object->getResponseHeader();
        $this->assertEquals('HTTP/1.1 200 OK', $result[0]);
    }

    /**
     * @covers ByJG\Util\WebRequest::addRequestHeader
     */
    public function testAddRequestHeader()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ByJG\Util\WebRequest::addCookie
     */
    public function testAddCookie()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ByJG\Util\WebRequest::getFollowLocation
     */
    public function testGetFollowLocation()
    {
        $this->object->setFollowLocation(true);
        $this->assertTrue($this->object->getFollowLocation());

        $this->object->setFollowLocation(false);
        $this->assertFalse($this->object->getFollowLocation());
    }

    /**
     * @covers ByJG\Util\WebRequest::soapCall
     * @todo   Implement testSoapCall().
     */
    public function testSoapCall()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ByJG\Util\WebRequest::setCurlOption
     * @covers ByJG\Util\WebRequest::getCurlOption
     */
    public function testSetCurlOption()
    {
        $this->object->setCurlOption(CURLOPT_NOBODY, true);
        $this->assertTrue($this->object->getCurlOption(CURLOPT_NOBODY));
    }

    /**
     * @covers ByJG\Util\WebRequest::get
     */
    public function testGet1()
    {
		$response = $this->object->get();
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => null,
            'method' => 'GET',
            'query_string' => [],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::get
     */
    public function testGet2()
    {
		$response = $this->object->get(['param1' => 'value1', 'param2' => 'value2']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => null,
            'method' => 'GET',
            'query_string' => ['param1' => 'value1', 'param2' => 'value2'],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::get
     */
    public function testGet3()
    {
		$response = $this->object->get('just_string');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => null,
            'method' => 'GET',
            'query_string' => ['just_string' => ''],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::get
     */
    public function testGet4()
    {
		$response = $this->object->get('just_string=value1&just_string2=value2');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => null,
            'method' => 'GET',
            'query_string' => ['just_string' => 'value1', 'just_string2' => 'value2'],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::get
     */
    public function testGet5()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extraparam=ok');
		$response = $this->object->get(['param1' => 'value1']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => null,
            'method' => 'GET',
            'query_string' => ['extraparam' => 'ok', 'param1' => 'value1'],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::post
     */
    public function testPost1()
    {
		$response = $this->object->post();
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'POST',
            'query_string' => [],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::post
     */
    public function testPost2()
    {
		$response = $this->object->post(['param1' => 'value1', 'param2' => 'value2']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'POST',
            'query_string' => [],
            'post_string' => ['param1' => 'value1', 'param2' => 'value2'],
            'payload' => 'param1=value1&param2=value2'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::post
     */
    public function testPost3()
    {
		$response = $this->object->post('just_string');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'POST',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'just_string'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::post
     */
    public function testPost4()
    {
		$response = $this->object->post('just_string=value1&just_string2=value2');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'POST',
            'query_string' => [],
            'post_string' => ['just_string' => 'value1', 'just_string2' => 'value2'],
            'payload' => 'just_string=value1&just_string2=value2'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::post
     */
    public function testPost5()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extra=ok');
		$response = $this->object->post(['param' => 'value']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'POST',
            'query_string' => ['extra' => 'ok'],
            'post_string' => ['param' => 'value'],
            'payload' => 'param=value'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::postPayload
     * @todo   Implement testPostPayload().
     */
    public function testPostPayload()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extra=ok');
		$response = $this->object->postPayload('{teste: "ok"}', 'application/json');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/json',
            'method' => 'POST',
            'query_string' => ['extra' => 'ok'],
            'post_string' => [],
            'payload' => '{teste: "ok"}'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::put
     */
    public function testPut1()
    {
		$response = $this->object->put();
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'PUT',
            'query_string' => [],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::put
     */
    public function testPut2()
    {
		$response = $this->object->put(['param1' => 'value1', 'param2' => 'value2']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'PUT',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'param1=value1&param2=value2'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::put
     */
    public function testPut3()
    {
		$response = $this->object->put('just_string');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'PUT',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'just_string'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::put
     */
    public function testPut4()
    {
		$response = $this->object->put('just_string=value1&just_string2=value2');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'PUT',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'just_string=value1&just_string2=value2'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::put
     */
    public function testPut5()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extra=ok');
		$response = $this->object->put(['param' => 'value']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'PUT',
            'query_string' => ['extra' => 'ok'],
            'post_string' => [],
            'payload' => 'param=value'
        ];
        $this->assertEquals($expected, $result);
    }


    /**
     * @covers ByJG\Util\WebRequest::putPayload
     */
    public function testPutPayload()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extra=ok');
		$response = $this->object->putPayload('{teste: "ok"}', 'application/json');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/json',
            'method' => 'PUT',
            'query_string' => ['extra' => 'ok'],
            'post_string' => [],
            'payload' => '{teste: "ok"}'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::delete
     */
    public function testDelete1()
    {
		$response = $this->object->delete();
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'DELETE',
            'query_string' => [],
            'post_string' => [],
            'payload' => ''
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::delete
     */
    public function testDelete2()
    {
		$response = $this->object->delete(['param1' => 'value1', 'param2' => 'value2']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'DELETE',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'param1=value1&param2=value2'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::delete
     */
    public function testDelete3()
    {
		$response = $this->object->delete('just_string');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'DELETE',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'just_string'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::delete
     */
    public function testDelete4()
    {
		$response = $this->object->delete('just_string=value1&just_string2=value2');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'DELETE',
            'query_string' => [],
            'post_string' => [],
            'payload' => 'just_string=value1&just_string2=value2'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::delete
     */
    public function testDelete5()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extra=ok');
		$response = $this->object->delete(['param' => 'value']);
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/x-www-form-urlencoded',
            'method' => 'DELETE',
            'query_string' => ['extra' => 'ok'],
            'post_string' => [],
            'payload' => 'param=value'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::deletePayload
     */
    public function testDeletePayload()
    {
        $this->object = new WebRequest(self::SERVER_TEST . '?extra=ok');
		$response = $this->object->deletePayload('{teste: "ok"}', 'application/json');
		$this->assertEquals(200, $this->object->getLastStatus());
        $result = json_decode($response, true);
        $expected = [
            'content-type' => 'application/json',
            'method' => 'DELETE',
            'query_string' => ['extra' => 'ok'],
            'post_string' => [],
            'payload' => '{teste: "ok"}'
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ByJG\Util\WebRequest::redirect
     */
    public function testRedirect()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ByJG\Util\WebRequest::curlWrapper
     */
    public function testCurlException()
    {
        $this->object = new WebRequest('http://laloiuyakkkall.iiiuqq/');

        $this->setExpectedException('\ByJG\Util\CurlException');
        $this->object->get();

    }

    public function testCurlAlone()
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://xpto.us/webrequest-test/rest.php');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded' ]);
		$result = curl_exec($curl);
        $error = curl_error($curl);
		if ($result === false)
		{
			curl_close($curl);
			throw new CurlException("CURL - " . $error);
		}

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$lastStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$this->assertEquals(200, $lastStatus);

        echo $result;
    }

    public function testCurlAlone_2()
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://xpto.us/webrequest-test/rest.php');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POST, true);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded' ]);
		$result = curl_exec($curl);
        $error = curl_error($curl);
		if ($result === false)
		{
			curl_close($curl);
			throw new CurlException("CURL - " . $error);
		}

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$lastStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$this->assertEquals(200, $lastStatus);

        echo $result;
    }

    public function testCurlAlone_3()
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://xpto.us/webrequest-test/rest.php');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		//curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded' ]);
		$result = curl_exec($curl);
        $error = curl_error($curl);
		if ($result === false)
		{
			curl_close($curl);
			throw new CurlException("CURL - " . $error);
		}

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$lastStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$this->assertEquals(200, $lastStatus);

        echo $result;
    }

    public function testCurlAlone_4()
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://xpto.us/webrequest-test/rest.php');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded' ]);
        curl_setopt($curl, 10015, '');

		$result = curl_exec($curl);
        $error = curl_error($curl);
		if ($result === false)
		{
			curl_close($curl);
			throw new CurlException("CURL - " . $error);
		}

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$lastStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$this->assertEquals(200, $lastStatus);

        echo $result;
    }

    public function testCurlAlone_5()
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://xpto.us/webrequest-test/rest.php');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded' ]);
        curl_setopt($curl, 10015, '[]');

		$result = curl_exec($curl);
        $error = curl_error($curl);
		if ($result === false)
		{
			curl_close($curl);
			throw new CurlException("CURL - " . $error);
		}

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$lastStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$this->assertEquals(200, $lastStatus);

        echo $result;
    }

}
