<?php

namespace Rennokki\Rating\Test;

use Rennokki\Rating\Test\Models\Page;
use Rennokki\Rating\Test\Models\User;

class RatingTest extends TestCase
{
    protected $user;
    protected $user2;
    protected $user3;
    protected $page;
    protected $simplePage;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\Rennokki\Rating\Test\Models\User::class)->create();
        $this->user2 = factory(\Rennokki\Rating\Test\Models\User::class)->create();
        $this->user3 = factory(\Rennokki\Rating\Test\Models\User::class)->create();
        $this->page = factory(\Rennokki\Rating\Test\Models\Page::class)->create();
        $this->simplePage = factory(\Rennokki\Rating\Test\Models\SimplePage::class)->create();
    }

    public function testNoImplements()
    {
        $this->assertFalse($this->user->rate($this->simplePage, 10.00));
        $this->assertFalse($this->user->unrate($this->simplePage));
        $this->assertFalse($this->user->hasRated($this->simplePage));
    }

    public function testNoRatersOrRating()
    {
        $this->assertEquals($this->user->ratings()->count(), 0);
        $this->assertEquals($this->user->raters()->count(), 0);

        $this->assertEquals($this->user2->ratings()->count(), 0);
        $this->assertEquals($this->user2->raters()->count(), 0);

        $this->assertEquals($this->user3->ratings()->count(), 0);
        $this->assertEquals($this->user3->raters()->count(), 0);
    }

    public function testRateUser()
    {
        $this->assertTrue($this->user->rate($this->user2, 10.00));

        $this->assertFalse($this->user->rate($this->user2, 10.00));
        $this->assertTrue($this->user->hasRated($this->user2));

        $this->assertTrue($this->user2->rate($this->user3, 5.00));
        $this->assertFalse($this->user2->rate($this->user3, 10.00));
        $this->assertTrue($this->user2->hasRated($this->user3));

        $this->assertFalse($this->user->hasRated($this->user3));
        $this->assertFalse($this->user3->hasRated($this->user2));

        $this->assertEquals($this->user->ratings()->count(), 1);
        $this->assertEquals($this->user->raters()->count(), 0);
        $this->assertEquals($this->user2->ratings()->count(), 1);
        $this->assertEquals($this->user2->raters()->count(), 1);
        $this->assertEquals($this->user3->ratings()->count(), 0);
        $this->assertEquals($this->user3->raters()->count(), 1);
    }

    public function testUnrateUser()
    {
        $this->assertFalse($this->user->unrate($this->user2));

        $this->assertTrue($this->user->rate($this->user2, 10.00));
        $this->assertTrue($this->user->unrate($this->user2));
        $this->assertFalse($this->user->hasRated($this->user2));

        $this->assertEquals($this->user->ratings()->count(), 0);
        $this->assertEquals($this->user->raters()->count(), 0);
        $this->assertEquals($this->user2->ratings()->count(), 0);
        $this->assertEquals($this->user2->raters()->count(), 0);
    }

    public function testUpdateRating()
    {
        $this->assertTrue($this->user->rate($this->user2, 10.00));
        $this->assertEquals($this->user2->averageRating(), 10.00);

        $this->assertTrue($this->user->updateRatingFor($this->user2, 1.00));
        $this->assertEquals($this->user2->averageRating(), 1.00);
    }

    public function testRateOtherModel()
    {
        $this->assertTrue($this->user->rate($this->page, 10.00));
        $this->assertFalse($this->user->rate($this->page, 10.00));
        $this->assertTrue($this->user->hasRated($this->page));

        $this->assertTrue($this->user2->rate($this->page, 7.00));
        $this->assertTrue($this->user3->rate($this->page, 5.00));

        $this->assertFalse($this->page->hasRated($this->user));
        $this->assertFalse($this->page->hasRated($this->user2));
        $this->assertFalse($this->page->hasRated($this->user3));

        $this->assertEquals($this->page->ratings()->count(), 0);
        $this->assertEquals($this->page->raters()->count(), 0);
        $this->assertEquals($this->page->ratings(User::class)->count(), 0);
        $this->assertEquals($this->page->raters(User::class)->count(), 3);

        $this->assertEquals($this->user->ratings()->count(), 0);
        $this->assertEquals($this->user->raters()->count(), 0);
        $this->assertEquals($this->user->ratings(Page::class)->count(), 1);
        $this->assertEquals($this->user->raters(Page::class)->count(), 0);

        $this->assertEquals($this->user2->ratings()->count(), 0);
        $this->assertEquals($this->user2->raters()->count(), 0);
        $this->assertEquals($this->user2->ratings(Page::class)->count(), 1);
        $this->assertEquals($this->user2->raters(Page::class)->count(), 0);

        $this->assertEquals($this->user3->ratings()->count(), 0);
        $this->assertEquals($this->user3->raters()->count(), 0);
        $this->assertEquals($this->user3->ratings(Page::class)->count(), 1);
        $this->assertEquals($this->user3->raters(Page::class)->count(), 0);
    }

    public function testUnrateOtherModel()
    {
        $this->assertFalse($this->user->unrate($this->page));

        $this->assertTrue($this->user->rate($this->page, 10.00));
        $this->assertTrue($this->user->unrate($this->page));
        $this->assertFalse($this->user->hasRated($this->page));

        $this->assertEquals($this->user->ratings()->count(), 0);
        $this->assertEquals($this->user->raters()->count(), 0);
        $this->assertEquals($this->user->ratings(Page::class)->count(), 0);
        $this->assertEquals($this->user->raters(Page::class)->count(), 0);
        $this->assertEquals($this->page->ratings()->count(), 0);
        $this->assertEquals($this->page->raters()->count(), 0);
        $this->assertEquals($this->page->ratings(User::class)->count(), 0);
        $this->assertEquals($this->page->raters(User::class)->count(), 0);
    }

    public function testUpdateRatingForOtherModel()
    {
        $this->assertTrue($this->user->rate($this->page, 10.00));
        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), 10.00);

        $this->assertTrue($this->user->updateRatingFor($this->page, 1.00));
        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), 1.00);
    }

    public function testAverageRating1()
    {
        $this->user->rate($this->page, 10.00);
        $this->user2->rate($this->page, 10.00);
        $this->user3->rate($this->page, 10.00);

        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), 10.00);
    }

    public function testAverageRating2()
    {
        $this->user->rate($this->page, 1.00);
        $this->user2->rate($this->page, 1.00);
        $this->user3->rate($this->page, 1.00);

        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), 1.00);
    }

    public function testAverageRating3()
    {
        $this->user->rate($this->page, 1.00);
        $this->user2->rate($this->page, 2.00);
        $this->user3->rate($this->page, 3.00);

        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), 2.00);
    }

    public function testAverageRating4()
    {
        $this->user->rate($this->page, 1.00);
        $this->user2->rate($this->page, 2.00);

        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), 1.50);
    }

    public function testAverageRating5()
    {
        $this->user->rate($this->page, 1.00);
        $this->user2->rate($this->page, 1.00);
        $this->user3->rate($this->page, 10.00);

        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), (12.00 / 3));
    }

    public function testAverageRating6()
    {
        $this->user->rate($this->page, 7.43);
        $this->user2->rate($this->page, 3.15);
        $this->user3->rate($this->page, 5.77);

        $this->assertEquals($this->page->averageRating(), 0.00);
        $this->assertEquals($this->page->averageRating(User::class), ((7.43 + 3.15 + 5.77) / 3));
    }
}
