<?php

namespace App\Factory;

use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Tache;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\lazy;

/**
 * @extends PersistentProxyObjectFactory<Tache>
 */
final class TacheFactory extends PersistentProxyObjectFactory
{
    private StatutRepository $statutRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(StatutRepository $statutRepository, EntityManagerInterface $entityManager)
    {
        $this->statutRepository = $statutRepository;
        $this->entityManager = $entityManager;
    }

    public static function class(): string
    {
        return Tache::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'projet' => ProjetFactory::random(),
            'statut' => lazy(fn() =>$this->getRandomStatut()), // TODO add App\Entity\Statut type manually
            'titre' => self::faker()->sentence(3),
            'description' => self::faker()->text(100),
            'deadline' => self::faker()->dateTime(),
            'employe' => LazyValue::new(function() {
                $projet = ProjetFactory::random();
                if (!$projet) {
                    return null;
                }
                $employes = $projet->getEmployes()->toArray();
                if (!empty($employes) && self::faker()->boolean(50)) {
                    return self::faker()->randomElement($employes);
                }
                return null;
            }),

        ];
    }

    private function getRandomStatut(): ?Statut
    {
        $statuts = $this->statutRepository->findAll();

        if (empty($statuts)) {
            $defaultStatuts = ['To Do', 'Doing', 'Done'];

            foreach ($defaultStatuts as $libelle) {
                $statut = new Statut();
                $statut->setLibelle($libelle);
                $this->entityManager->persist($statut);
                $statuts[] = $statut;
            }

            $this->entityManager->flush();
        }

        return $statuts[array_rand($statuts)];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Tache $tache): void {})
        ;
    }
}
