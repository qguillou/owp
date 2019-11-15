<?php

namespace App\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Menu;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;

final class MenuBlock extends AbstractBlockService
{
    private $doctrine;

    public function __construct($templatingOrDeprecatedName = null, EngineInterface $templating = null, EntityManager $doctrine = null)
    {
        parent::__construct($templatingOrDeprecatedName, $templating);

        $this->doctrine = $doctrine;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse('Common/Block/menu_block.html.twig', [
            'menus'     => $this->doctrine->getRepository(Menu::class)->findBy([]),
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings()
        ], $response);
    }
}
