<?php
namespace App\Factory;

use App\Entity\Project;
use DateTimeImmutable;
use Zenstruck\Foundry\ModelFactory;

final class ProjectFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->word(),
            'startAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'deadline' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'archived' => self::faker()->boolean(),
            'tasks' => TaskFactory::new()->many(3),
            'status' => StatusFactory::randomOrCreate(),
//            'employes' => EmployeFactory::randomOrCreate(),
//            'tags' => TagFactory::randomOrCreate(),
        ];
    }

    protected static function getClass(): string
    {
        return Project::class;
    }

    protected function initialize(): self
    {
        return $this->afterInstantiate(function(Project $project): void {
            $employes = EmployeFactory::randomRange(2, 4);
            foreach ($employes as $employe) {
                $project->addEmploye($employe->object());
            }

            $tags = TagFactory::randomRange(1, 3);
            foreach ($tags as $tag) {
                $project->addTag($tag->object());
            }

        });
    }
}
