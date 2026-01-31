# Async Document Processing Demo (Laravel)

This project demonstrates how a Laravel backend can handle slow or heavy tasks
using asynchronous processing with queues, events, and background jobs.

The focus is on **backend architecture and behavior**, not on building a full product.

---

## Why this project exists

Most demo projects focus on CRUD operations.
Real backend systems must also handle:

- Asynchronous processing
- Background jobs
- Failure and retry behavior
- Safe execution of duplicated tasks
- Clear separation of responsibilities

This project was built to explore and demonstrate those concepts in a simple and observable way.

---

## High-level flow

1. A user uploads a document
2. The controller validates and stores basic data only
3. A `DocumentUploaded` event is dispatched
4. A listener reacts to the event
5. Multiple background jobs are dispatched
6. Jobs run asynchronously using Laravel queues
7. The document status is updated as jobs complete

---

## Architecture overview

### Controller
- Handles validation and persistence only
- Does not contain business or processing logic

### Event
- Represents a fact: `DocumentUploaded`
- Has no side effects by itself

### Listener
- Runs synchronously
- Dispatches background jobs
- Keeps orchestration separate from execution

### Jobs
- Executed asynchronously using the queue system
- Each job has a single responsibility
- Jobs are idempotent (safe to run more than once)
- Retry behavior is configurable using `$tries`

---

## Jobs in this project

- **ProcessDocumentJob**
  - Simulates heavy document processing
  - Updates document status

- **ExtractDocumentMetadataJob**
  - Simulates metadata extraction
  - Runs independently from other jobs

Jobs are dispatched once per upload and processed asynchronously by a queue worker.

---

## Retry behavior

Laravel jobs support retrying failed executions using the `$tries` property.

In this demo:
- Retry behavior is kept minimal to avoid confusing non-technical viewers
- The concept of retries is explained rather than aggressively demonstrated

This keeps the execution flow clear while still reflecting real-world backend behavior.

---

## Demonstration UI

A minimal UI is included to visualize how documents move through the
asynchronous processing pipeline.

The UI is intentionally simple and exists only to:
- Upload documents
- Display current document status
- Make background job execution observable

The UI does not introduce additional business logic.

---

## Running the project locally

Basic steps:

1. Configure your database connection
2. Run migrations
3. Start the queue worker

```bash
php artisan migrate
php artisan queue:work