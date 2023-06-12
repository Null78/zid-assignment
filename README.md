## Backend Assignment

## Task
You were given a sample [Laravel][laravel] project which implements sort of a personal wishlist
where user can add their wanted products with some basic information (price, link etc.) and
view the list.

#### Refactoring
The `ItemController` is messy. Please use your best judgement to improve the code. Your task
is to identify the imperfect areas and improve them whilst keeping the backwards compatibility.

#### New feature
Please modify the project to add statistics for the wishlist items. Statistics should include:

- total items count
- average price of an item
- the website with the highest total price of its items
- total price of items added this month

The statistics should be exposed using an API endpoint. **Moreover**, user should be able to
display the statistics using a CLI command.

Please also include a way for the command to display a single information from the statistics,
for example just the average price. You can add a command parameter/option to specify which
statistic should be displayed.

## Open questions
Please write your answers to following questions.

> **Please briefly explain your implementation of the new feature**  
>  #### API Endpoint
>  created a seprate invokable controller that returns the statistics for the whishlist items
>  using Laravel Eloquent Models to query needed data then transform it with Laravel Collections to produce the desired output.
>
> #### Console Command
> using the power of laravel artisan commands i have added a new command named items:stats that display a table of all the statistics by default and it also can be customized to display only one or more stat using options like --average or --total
>
> #### Overall
> i believe that the statistics can be implemented more dynamiclly and implemented as a Trait, to generalize the logic so it can be used with any model and to also allow for custom arguments in the case of total price of items added this month, if the period is a parametar we can have the statistics of any period of time not just the current month

> **For the refactoring, would you change something else if you had more time?**  
> 
> In this limited context I would create a Website Model that contains the name and url of every Website, and then every Item will belong to a Website, this will enhance the performance of the statistics as the the items group by website will be executed at the database level insted of the application level, it will also reduce the size of each entry as we will not need to store the full url of every item, insted we just have keep the item ID and concatenate it with the website url on client side
> 

## Running the project
This project requires a database to run. For the server part, you can use `php artisan serve`
or whatever you're most comfortable with.

You can use the attached DB seeder to get data to work with.

#### Running tests
The attached test suite can be run using `php artisan test` command.

[laravel]: https://laravel.com/docs/8.x
