<?php

namespace App\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;
use Owp\OwpCore\Repository\UserRepository;

final class AdminStatBlock extends AbstractBlockService
{
    private $userRepository;

    public function __construct(Environment $templatingOrDeprecatedName, EngineInterface $templating, UserRepository $userRepository)
    {
        parent::__construct($templatingOrDeprecatedName, $templating);

        $this->userRepository = $userRepository;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse('@OwpCore/Administration/Block/admin_stat_block.html.twig', [
            'users'     => $this->userRepository->count([]),
        ], $response);
    }
}
