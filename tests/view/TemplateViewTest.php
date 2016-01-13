<?php
namespace view;

use view\TemplateView;

/**
 *
 * @author eaboxt
 *        
 */
class TemplateViewTest extends \PHPUnit_Framework_TestCase
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
        $file = __DIR__ . '/tpl/parsed/simple.txt';
        
        $tpl = new TemplateView($file);
        $result = $tpl->render();
        
        $this->assertEquals('test', $result);
    }
    
    public function testLoadNonExistingTpl()
    {
        $file = __DIR__ . '/tpl/parsed/pathtononexistingtemplate.txt';
    
        $tpl = new TemplateView($file);
        try{
            $tpl->render(); // should throw an exception
            $this->fail('Expected an exception');
        } catch(\view\ViewException $ex){
            //
        }
    }

    public function testTplWithVar()
    {
        $file = __DIR__ . '/tpl/parsed/var.txt';
        
        $tpl = new TemplateView($file);
        $tpl->{'test'} = 'test';
        $result = $tpl->render();
        
        $this->assertEquals('test test test', $result);
    }

    public function testTplWithFunction()
    {
        $file = __DIR__ . '/tpl/parsed/function.txt';
        
        $tpl = new TemplateView($file);
        $tpl->{'test'} = function ()
        {
            return 'test';
        };
        $result = $tpl->render();
        
        $this->assertEquals('test test test', $result);
    }

    public function testTplWithFunctionArgs()
    {
        $file = __DIR__ . '/tpl/parsed/function-args.txt';
        
        $tpl = new TemplateView($file);
        $tpl->{'test'} = function ($arg1, $arg2)
        {
            return $arg1 . ' ' . $arg2;
        };
        $result = $tpl->render();
        
        $this->assertEquals('test1 test2', $result);
    }
    
    public function testTplWithIfTrue()
    {
        $file = __DIR__ . '/tpl/parsed/if.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = true;
        $result = $tpl->render();
    
        $this->assertEquals('1 test 2', $result);
    }
    
    public function testTplWithIfFalse()
    {
        $file = __DIR__ . '/tpl/parsed/if.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = false;
        $result = $tpl->render();
    
        $this->assertEquals('1  2', $result);
    }
    
    public function testTplWithNotIfTrue()
    {
        $file = __DIR__ . '/tpl/parsed/not-if.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = true;
        $result = $tpl->render();
    
        $this->assertEquals('1  2', $result);
    }
    
    public function testTplWithNotIfFalse()
    {
        $file = __DIR__ . '/tpl/parsed/not-if.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = false;
        $result = $tpl->render();
    
        $this->assertEquals('1 test 2', $result);
    }
    
    public function testTplWithExpressionEq()
    {
        $file = __DIR__ . '/tpl/parsed/expression-eq-string.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = 'asdf';
        $result = $tpl->render();
    
        $this->assertEquals('1 test 2', $result);
    }
    
    public function testTplWithExpressionEqFalse()
    {
        $file = __DIR__ . '/tpl/parsed/expression-eq-string.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = 'asdf_';
        $result = $tpl->render();
    
        $this->assertEquals('1  2', $result);
    }
    
    public function testTplWithExpressionVarEq()
    {
        $file = __DIR__ . '/tpl/parsed/expression-eq-var.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = 'asdf';
        $tpl->{'test2'} = 'asdf';
        $result = $tpl->render();
    
        $this->assertEquals('1 test 2', $result);
    }
    
    public function testTplWithExpressionEqVarFalse()
    {
        $file = __DIR__ . '/tpl/parsed/expression-eq-var.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = 'asdf';
        $tpl->{'test2'} = 'asdf_';
        $result = $tpl->render();
    
        $this->assertEquals('1  2', $result);
    }
    
    public function testTplWithExpressionUnknowsFailure()
    {
        $file = __DIR__ . '/tpl/parsed/expression-non-existing.txt';
    
        $tpl = new TemplateView($file);
        try{
            $result = $tpl->render();
            $this->fail('expected exception');
        } catch(\Exception $e) {
            $this->assertEquals('Operator >< in expression not supported', $e->getMessage());
        }
    }
    
    public function testTplListArray()
    {
        $file = __DIR__ . '/tpl/parsed/list.txt';
    
        $tpl = new TemplateView($file);
        $tpl->{'test'} = array('1','2','3');
        $result = $tpl->render();
    
        $this->assertEquals('1 2 3 ', $result);
    }
    
}