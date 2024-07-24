<?php

namespace App\Factory;

use App\Entity\Employe;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Employe>
 */
final class EmployeFactory extends PersistentProxyObjectFactory{
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
        return Employe::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'active' => self::faker()->numberBetween(0, 1),
            'arrivalAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'contract' => self::faker()->randomElement(['CDI', 'CDD']),
            'email' => self::faker()->unique()->email,
            'firstname' => self::faker()->firstName,
            'lastname' => self::faker()->lastName,
            'password' => self::faker()->password,
            'role' => self::faker()->numberBetween(0, 1),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Employe $employe): void {})
        ;
    }
}
