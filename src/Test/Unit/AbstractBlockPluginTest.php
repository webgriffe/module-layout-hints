<?php


namespace Webgriffe\LayoutHints\Test\Unit;

use Webgriffe\LayoutHints\AbstractBlockPlugin;

class AbstractBlockPluginTest extends \PHPUnit_Framework_TestCase
{
    public function testAroundToHtmlAddsBlockHints()
    {
        $scopeConfig = $this->prophesize('Magento\Framework\App\Config\ScopeConfigInterface');
        $scopeConfig->isSetFlag('dev/debug/layout_hints_front_enabled', 'store')->willReturn(true);
        $abstractBlock = $this->prophesize('Magento\Framework\View\Element\AbstractBlock');
        $abstractBlock->getNameInLayout()->willReturn('block_name');
        $proceed = function () {
            return '<p class="html">Hello!</p>';
        };

        $plugin = new AbstractBlockPlugin($scopeConfig->reveal());

        $this->assertEquals(
            '<!-- [BLOCK BEGIN type="Magento\Framework\View\Element\AbstractBlock" name="block_name"] -->' .
            '<p class="html">Hello!</p>' .
            '<!-- [BLOCK END type="Magento\Framework\View\Element\AbstractBlock" name="block_name"] -->',
            $plugin->aroundToHtml($abstractBlock->reveal(), $proceed)
        );
    }

    public function testAroundToHtmlOfTemplateBlockAddsTemplateFile()
    {
        $scopeConfig = $this->prophesize('Magento\Framework\App\Config\ScopeConfigInterface');
        $scopeConfig->isSetFlag('dev/debug/layout_hints_front_enabled', 'store')->willReturn(true);
        $templateBlock = $this->prophesize('Magento\Framework\View\Element\Template');
        $templateBlock->getNameInLayout()->willReturn('block_name');
        $templateBlock->getTemplate()->willReturn('Magento_Module::template.phtml');
        $templateBlock->getTemplateFile()->willReturn('/path/to/template.phtml');
        $proceed = function () {
            return '<p class="html">Hello!</p>';
        };

        $plugin = new AbstractBlockPlugin($scopeConfig->reveal());

        $this->assertEquals(
            '<!-- [BLOCK BEGIN type="Magento\Framework\View\Element\Template" name="block_name" template="Magento_Module::template.phtml" currentTemplate="/path/to/template.phtml"] -->' .
            '<p class="html">Hello!</p>' .
            '<!-- [BLOCK END type="Magento\Framework\View\Element\Template" name="block_name" template="Magento_Module::template.phtml" currentTemplate="/path/to/template.phtml"] -->',
            $plugin->aroundToHtml($templateBlock->reveal(), $proceed)
        );
    }
}
