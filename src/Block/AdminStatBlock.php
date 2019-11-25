<?php

namespace App\Block;

use Doctrine\ORM\EntityManager;
use Owp\OwpCore\Entity\User;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

final class AdminStatBlock extends AbstractBlockService
{
    private $doctrine;

    public function __construct($templatingOrDeprecatedName = null, EngineInterface $templating = null, EntityManager $doctrine = null)
    {
        parent::__construct($templatingOrDeprecatedName, $templating);

        $this->doctrine = $doctrine;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse('Administration/Block/admin_stat_block.html.twig', [
            'users'     => $this->doctrine->getRepository(User::class)->count([]),
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings()
        ], $response);
    }
}
