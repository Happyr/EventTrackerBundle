# Happyr Event Tracker Bundle

This bundle helps you log changes in your application. It is used to connect an entity and user with an event and time.
 You may later query this log to get the history of the event. Example when you want to know who edited the blog post.

This is similar to [Hostnet entity tracker](https://github.com/hostnet/entity-tracker-component) but we do not listen to
doctrine lifecycle events, we let you configure your own events.

## Usage

Install the bundle with `composer require happyr/event-tracker-bundle`, and let your events implement `TrackableEventInterface`.
 Then you only need to configure for which events you want to have tracked.


``` yml
happyr_event_tracker:
  events:
    acme.blog_post.created:
        namespace: blogpost
        action: created
    acme.blog_post.updated:
        namespace: blogpost
        action: updated
    acme.comment.created:
        namespace: comment
        action: created
```
