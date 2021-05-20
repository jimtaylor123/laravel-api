# Laravel API

The aim of this project is to create a boiler plate Laravel API

## Done
* UUIDs for all models ✅

## To do
* Basic model set up
* Json API spec compliant
* Generic controller methods for common crud actions
* Generator for quickly creating crud models
* Generation by YAML?
* Self documentation, ie documentation within the code base
* Translation for localization
* Error handling
* Authentication with Laravel passport
* Larastan for standards
* CS fixer for free auto fixing of errors
* PestPHP for testing
* Telescope for app management
* Laravel scout for search with Elastic search driver
* Redis cache
* Cron job scheduled tasks
* Queuing 
* Notifications - emails, slack, sms
* Fully typed
* ELB on AWS for deployment or managed kubernetes on digital ocean?
* Logging with papertrail
* Custom exceptions
* Multiple db connections - sql and nosql
* Laravel cashier and stripe for payments
  

We will use the following example task app as our basis:

Account > Organizations > Users
* Accounts for payment
* Accounts are paid by organizations (typically a limited company, but could be a sole trader etc)
* Accounts have a responsible person, a member of one of the organizations of an account

However, what if you want to invite an external user or assign tasks across different organizations? 
* Teams, so you can assign a task to someone by adding them to a team

More about users:
* Can be internal or external
 * Have roles and permissions

Projects => tasks => comments
* Projects have tasks and both projects and tasks can have comments
* Users can be owners of a project and/or a task
* A task can only be owned by one person, but a project can be owned by many users
* Projects/tasks can be dependent on other projects/tasks
* Comments can be chained in a hierarchy, just like blog comments

We will have an onboarding process for new accounts, new organizations and new users


# Passport values for dev

## Personal access client created successfully.
Here is your new client secret. This is the only time it will be shown so don't lose it!

Client ID: 9379c079-25cc-42a9-adfa-159628fb9b2d
Client secret: jYN9HZSeG1ClEbTMjVEFQpeBbSuzrcC8eFhtQde5

## Password grant client created successfully.
Here is your new client secret. This is the only time it will be shown so don't lose it!

Client ID: 9379c079-5294-4160-ae2f-09a4daf33d6c
Client secret: RKR37tLyaONBNIj5R65tXSxdX8PCybC8gVjHPnsD

