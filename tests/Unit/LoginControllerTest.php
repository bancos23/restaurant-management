<?php

use App\Controller\LoginController;
use Mockery;
use PHPUnit\Framework\TestCase;

beforeEach(function () {
    $this->mockPDO = Mockery::mock(PDO::class);
    $this->mockStatement = Mockery::mock(PDOStatement::class);
    $this->controller = new LoginController($this->mockPDO);
});

afterEach(function () {
    Mockery::close();
});

it('can verify passwords correctly', function () {
    $password = 'password123';
    $userPassword = 'passw2ord123';

    expect($this->controller->verifyPassword($password, $userPassword))->toBeFalse();
});

it('returns false for wrong password in performLogin', function () {
    $this->mockPDO->shouldReceive('prepare')
        ->once()
        ->with('SELECT * FROM `users` WHERE `username` = :username')
        ->andReturn($this->mockStatement);

    $this->mockStatement->shouldReceive('bindParam')
        ->once()
        ->with(':username', 'testuser');
    
    $this->mockStatement->shouldReceive('execute')->once();
    
    $this->mockStatement->shouldReceive('rowCount')->once()->andReturn(0);

    expect($this->controller->performLogin('testuser', 'wrongpassword'))->toBeFalse();
    expect($_SESSION['msg'])->toContain('Wrong password or username!');
});

it('returns true for correct password in performLogin', function () {
    $this->mockPDO->shouldReceive('prepare')
        ->once()
        ->with('SELECT * FROM `users` WHERE `username` = :username')
        ->andReturn($this->mockStatement);

    $this->mockStatement->shouldReceive('bindParam')
        ->once()
        ->with(':username', 'admin');
    
    $this->mockStatement->shouldReceive('execute')->once();
    
    $this->mockStatement->shouldReceive('rowCount')->once()->andReturn(1);
    $user = (object) ['id' => 1, 'password' => 'admin'];
    $this->mockStatement->shouldReceive('fetch')->once()->andReturn($user);
    
    expect($this->controller->performLogin('admin', 'admin'))->toBeTrue();
    expect($_SESSION['user'])->toBe(1);
});

it('handles PDO exception gracefully', function () {
    $this->mockPDO->shouldReceive('prepare')->once()->andThrow(new PDOException("Database error"));
    expect($this->controller->performLogin('test', 'parola'))->toBeFalse();
    expect($_SESSION['msg'])->toContain('An error occurred. Please try again later.');
});
