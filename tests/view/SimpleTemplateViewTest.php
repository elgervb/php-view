<?php
namespace view;

use view\SimpleTemplateView;

/**
 *
 * @author eaboxt
 *        
 */
class SimpleTemplateViewTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testLoadTpl()
    {
        $file = __DIR__ . '/tpl/simple/simple.txt';
        
        $tpl = new SimpleTemplateView($file);
        $result = $tpl->render();
        
        $this->assertEquals('test', $result);
    }
    
    public function testLoadNonExistingTpl()
    {
        $file = __DIR__ . '/tpl/simple/pathtononexistingtemplate.txt';
    
        $tpl = new SimpleTemplateView($file);
        try{
            $tpl->render(); // should throw an exception
            $this->fail('Expected an exception');
        } catch(\view\ViewException $ex){
            //
        }
    }

    public function testTplWithVar()
    {
        $file = __DIR__ . '/tpl/simple/var.txt';
        
        $tpl = new SimpleTemplateView($file);
        $tpl->{'test'} = 'test';
        $result = $tpl->render();
        
        $this->assertEquals('test test test', $result);
    }

    public function testTplWithFunction()
    {
        $file = __DIR__ . '/tpl/simple/function.txt';
        
        $tpl = new SimpleTemplateView($file);
        $tpl->{'test'} = function ()
        {
            return 'test';
        };
        $result = $tpl->render();
        
        $this->assertEquals('test test test', $result);
    }

    public function testTplWithFunctionArgs()
    {
        $file = __DIR__ . '/tpl/simple/function-args.txt';
        
        $tpl = new SimpleTemplateView($file);
        $tpl->{'test'} = function ($arg1, $arg2)
        {
            return $arg1 . ' ' . $arg2;
        };
        $result = $tpl->render();
        
        $this->assertEquals('test1 test2', $result);
    }
}