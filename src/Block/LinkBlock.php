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
use App\Entity\Link;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;

final class LinkBlock extends AbstractBlockService
{
    private $doctrine;

    public function __construct($templatingOrDeprecatedName = null, EngineInterface $templating = null, EntityManager $doctrine = null)
    {
        parent::__construct($templatingOrDeprecatedName, $templating);

        $this->doctrine = $doctrine;
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => 'Common/Block/link_block.html.twig',
        ]);
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {

    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->end()
        ;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $links = $this->doctrine->getRepository(Link::class)->findBy([]);

        return $this->renderResponse($blockContext->getTemplate(), [
            'links'     => $links,
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings()
        ], $response);
    }
}
