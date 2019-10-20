<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/20/19
 * Time: 1:53 PM
 */

namespace App\AppBundle\PokerHandsGameBundle\Enums;


/**
 * Number points ranking system for cards
 * Class CardPoints
 * @package App\AppBundle\PokerHandsGameBundle\Enums
 */
class CardPoints
{
    public const ROYAL_FLUSH = 1000;

    public const STRAIGHT_FLUSH = 900;

    public const FOUR_OF_A_KIND = 800;

    public const FULL_HOUSE = 700;

    public const FLUSH = 600;

    public const STRAIGHT = 500;

    public const THREE_OF_A_KIND = 400;

    public const TWO_PAIRS  = 300;

    public const ONE_PAIR = 200;

}