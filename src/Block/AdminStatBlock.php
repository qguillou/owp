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
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;

final class AdminStatBlock extends AbstractBlockService
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
            'title' => 'Dashboard',
            'template' => 'Administration/Block/admin_stat_block.html.twig',
        ]);
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper
            ->add('settings', 'sonata_type_immutable_array', [
                'keys' => [
                    ['title', 'text', ['required' => false]],
                ]
            ])
        ;
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->with('settings.title')
                ->assertNotNull([])
                ->assertNotBlank()
            ->end()
        ;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $users = $this->doctrine->getRepository(User::class)->count([]);

        return $this->renderResponse($blockContext->getTemplate(), [
            'users'     => $users,
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings()
        ], $response);
    }
}
