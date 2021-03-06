<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Tests;

use Tester\Assert;
use Dasuos\Mail;

require __DIR__ . '/../bootstrap.php';

class HtmlMessage extends \Tester\TestCase {

	public function testReturningAlternativeContentType() {
		Assert::same(
			['Content-Type' => 'multipart/alternative; boundary="random"'],
			preg_replace(
				'~[0-9a-z]{20}~',
				'random',
				(new Mail\HtmlMessage('<h1>Foo</h1><p>Bar</p>'))->headers()
			)
		);
	}

	public function testReturningPlainTextAndHtml() {
		Assert::same(
			preg_replace(
				'~\s+~', ' ',
				'--boundary 
				Content-Type: text/plain; charset=utf-8 
				Content-Transfer-Encoding: 7bit 
	
				\nFoo\n\nBar\n 
	
				--boundary  
				Content-Type: text/html; charset=utf-8 
				Content-Transfer-Encoding: 7bit 
					
				<h1>Foo</h1><p>Bar</p> 
	
				--boundary--'
			),
			preg_replace(
				'~[0-9a-z]{20}~', 'boundary',
				preg_replace(
					'~\s+~', ' ',
					(new Mail\HtmlMessage('<h1>Foo</h1><p>Bar</p>'))->content()
				)
			)
		);
	}

	public function testReturningSameBoundaries() {
		preg_match_all(
			'~[0-9a-z]{20}~',
			(new Mail\HtmlMessage('<h1>Foo</h1><p>Bar</p>'))->content(),
			$matches
		);
		Assert::true(count(array_unique($matches[0])) === 1);
	}
}

(new HtmlMessage())->run();
