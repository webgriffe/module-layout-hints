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
            '<!-- [BLOCK BEGIN type="Double\Magento\Framework\View\Element\AbstractBlock\P2" name="block_name" template=""] -->' .
            '<p class="html">Hello!</p>' .
            '<!-- [BLOCK END type="Double\Magento\Framework\View\Element\AbstractBlock\P2" name="block_name" template=""] -->',
            $plugin->aroundToHtml($abstractBlock->reveal(), $proceed)
        );
    }

    public function testAroundToHtmlOfTemplateBlockAddsTemplateFile()
    {
        $scopeConfig = $this->prophesize('Magento\Framework\App\Config\ScopeConfigInterface');
        $scopeConfig->isSetFlag('dev/debug/layout_hints_front_enabled', 'store')->willReturn(true);
        $templateBlock = $this->prophesize('Magento\Framework\View\Element\Template');
        $templateBlock->getNameInLayout()->willReturn('block_name');
        $templateBlock->getTemplateFile()->willReturn('/path/to/template.phtml');
        $proceed = function () {
            return '<p class="html">Hello!</p>';
        };

        $plugin = new AbstractBlockPlugin($scopeConfig->reveal());

        $this->assertEquals(
            '<!-- [BLOCK BEGIN type="Double\Magento\Framework\View\Element\Template\P4" name="block_name" template="/path/to/template.phtml"] -->' .
            '<p class="html">Hello!</p>' .
            '<!-- [BLOCK END type="Double\Magento\Framework\View\Element\Template\P4" name="block_name" template="/path/to/template.phtml"] -->',
            $plugin->aroundToHtml($templateBlock->reveal(), $proceed)
        );
    }
}
