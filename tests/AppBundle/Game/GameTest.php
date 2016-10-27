<?php

namespace tests\AppBundle\Game;

use AppBundle\Game\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{
    
    public function testGameInitialState()
    {
        $game = new Game('computer');
        
        $this->assertSame('computer', $game->getWord());
        $this->assertFalse($game->isWon());
        $this->assertFalse($game->isHanged());
        $this->assertFalse($game->isOver());
        $this->assertSame(0, $game->getAttempts());
        $this->assertSame(Game::MAX_ATTEMPTS, $game->getRemainingAttempts());
        
    }
    
    public function testGuessWord()
    {
        $game = new Game('training');
        
        $this->assertTrue($game->tryWord('training'));
        $this->assertTrue($game->isWon());
        $this->assertFalse($game->isHanged());
        $this->assertTrue($game->isOver());
    }
    
    public function testGuessWrongWord()
    {
        $game = new Game('training');
        
        $this->assertFalse($game->tryWord('foobar'));
        $this->assertFalse($game->isWon());
        $this->assertTrue($game->isHanged());
        $this->assertTrue($game->isOver());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /The letter ".*" is not a valid ASCII character matching \[a-z\]\./
     * @dataProvider provideInvalidLetterCharacter
     */
    public function testTryInvalidLetterCharacter($letter)
    {
        $game = new Game('monitors');
        $game->tryLetter($letter);
    }
    
    public function provideInvalidLetterCharacter()
    {
        return [
          ['tr'],
          [true],
          [false],
          [null],
          [1],
          [10],
          ['$'],
        ];
    }
    
    /**
     * #@dataProvider provideValidLetter
     */
    public function testTryValidLetter($letter)
    {
        $game = new Game('php');
        
        $this->assertTrue($game->tryLetter($letter));
        $this->assertTrue($game->isLetterFound($letter));
        $this->assertContains(strtolower($letter), $game->getFoundLetters());
        $this->assertContains(strtolower($letter), $game->getTriedLetters());
    }
    
    public function provideValidLetter()
    {
        return [
          ['p'],
          ['h'],
        ];
    }
    
    public function testTrySameLetterTwice()
    {
        $game = new Game('bobby');
        
        $this->assertTrue($game->tryLetter('b'));
        $this->assertFalse($game->tryLetter('b'));
        $this->assertSame(1, $game->getAttempts());
        $this->assertSame(Game::MAX_ATTEMPTS -1, $game->getRemainingAttempts());
    }
    
    public function testTryWrongLetter()
    {
        $game = new Game('bobby');
    
        $this->assertFalse($game->tryLetter('x'));
        $this->assertSame(1, $game->getAttempts());
        $this->assertSame(Game::MAX_ATTEMPTS -1, $game->getRemainingAttempts());
    
        $this->assertFalse($game->tryLetter('a'));
        $this->assertSame(2, $game->getAttempts());
        $this->assertSame(Game::MAX_ATTEMPTS -2, $game->getRemainingAttempts());
    }
    
}
