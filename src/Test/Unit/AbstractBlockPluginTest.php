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
            '<!-- [BLOCK BEGIN type="Double\Magento\Framework\View\Element\AbstractBlock\P2" name="block_name"] -->' .
            '<p class="html">Hello!</p>' .
            '<!-- [BLOCK END type="Double\Magento\Framework\View\Element\AbstractBlock\P2" name="block_name"] -->',
            $plugin->aroundToHtml($abstractBlock->reveal(), $proceed)
        );
    }
}
