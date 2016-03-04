<?php


namespace Webgriffe\LayoutHints;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class AbstractBlockPlugin
{
    const XML_PATH_LAYOUT_HINTS_FRONT_ENABLED = 'dev/debug/layout_hints_front_enabled';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundToHtml(AbstractBlock $subject, \Closure $proceed)
    {
        $html = $this->formatBlockComment('BLOCK BEGIN', $subject);
        $html .= $proceed();
        $html .= $this->formatBlockComment('BLOCK END', $subject);
        return $html;
    }

    /**
     * @param $prefix
     * @param AbstractBlock $subject
     * @return string
     */
    private function formatBlockComment($prefix, AbstractBlock $subject)
    {
        if ($this->scopeConfig->isSetFlag(self::XML_PATH_LAYOUT_HINTS_FRONT_ENABLED, ScopeInterface::SCOPE_STORE)) {
            return sprintf(
                '<!-- [%s type="%s" name="%s" template="%s"] -->',
                $prefix,
                get_class($subject),
                $subject->getNameInLayout(),
                $subject instanceof Template ? $this->relativizeTemplateFile($subject->getTemplateFile()) : ''
            );
        }
        return '';
    }

    private function relativizeTemplateFile($templateFile)
    {
        if (defined('BP')) {
            return ltrim(str_replace(BP, '', $templateFile), '/');
        }
        return $templateFile;
    }
}
