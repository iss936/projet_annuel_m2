<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractDataFixture implements ContainerAwareInterface, FixtureInterface, OrderedFixtureInterface
{

    /**
     * The dependency injection container.
     *
     * @var ContainerInterface
     */
    protected $container;

    protected $manager;
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
    	$this->manager = $manager;
        $kernel = $this->container->get('kernel');

        $this->doLoad();
    }

    /**
     * Performs the actual fixtures loading.
     *
     * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
     *
     * @param ObjectManager $manager The object manager.
     */
    abstract protected function doLoad();

    /**
     * Returns the environments the fixtures may be loaded in.
     *
     * @return array The name of the environments.
     */
    abstract protected function getEnvironments();

    /**
     * Allows you to define the location of fixtures in the execution stack
     */
    public function getOrder() {
        return 0;
    }
}
