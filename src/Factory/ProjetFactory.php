<?php

namespace App\Factory;

use App\Entity\Projet;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Projet>
 */
final class ProjetFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Projet::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'archive' => self::faker()->boolean(0),
            'nomProjet' => ucfirst(self::faker()->word()) . ' ' . self::faker()->randomElement(['Manager', 'System', 'App', 'Tool']),
            'employes' => LazyValue::new(fn() => EmployeFactory::randomRange(2, 10)),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Projet $projet): void {})
        ;
    }
}
