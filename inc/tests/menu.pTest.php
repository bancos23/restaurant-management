use PHPUnit\Framework\TestCase;

<?php

?>
<?php


class MenuPageTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        Config::setCon($this->pdo);
    }

    public function testFetchRecipes()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $this->pdo->method('prepare')->willReturn($stmt);

        $stmt->expects($this->once())->method('execute');
        $stmt->method('fetchAll')->willReturn([
            (object)[
                'recipe_name' => 'Recipe 1',
                'supply_name' => 'Supply 1',
                'quantity' => 2,
                'unit_name' => 'kg'
            ],
            (object)[
                'recipe_name' => 'Recipe 1',
                'supply_name' => 'Supply 2',
                'quantity' => 1,
                'unit_name' => 'liter'
            ],
            (object)[
                'recipe_name' => 'Recipe 2',
                'supply_name' => 'Supply 3',
                'quantity' => 3,
                'unit_name' => 'pcs'
            ]
        ]);

        ob_start();
        include '/Users/eduhaidu/restaurant-management/inc/pages/menu.p.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Recipe 1', $output);
        $this->assertStringContainsString('2kg supply 1', $output);
        $this->assertStringContainsString('1liter supply 2', $output);
        $this->assertStringContainsString('Recipe 2', $output);
        $this->assertStringContainsString('3pcs supply 3', $output);
    }
}
?>
