# Using Watched List Pattern in Node.js Applications

The Watcher pattern, also known as the Observer pattern, is a behavioral design pattern where an object (the subject) maintains a list of its dependents (observers) and notifies them of any state changes. In Node.js applications, this pattern can be particularly useful for managing real-time data mutations, such as an array of attachments in a post.

## WatchedList Example

A `WatchedList` is a specialized set of arrays containing current, initial, added, and removed items for each method in a single class. It's used when dealing with an array of items where real-time data mutation is required.

Here's an example implementation of a `WatchedList`:

```javascript
export abstract class WatchedList<T> {
  public currentItems: T[];
  private initial: T[];
  private new: T[];
  private removed: T[];

  constructor(initialItems?: T[]) {
    this.currentItems = initialItems || [];
    this.initial = initialItems || [];
    this.new = [];
    this.removed = [];
  }

  abstract compareItems(a: T, b: T): boolean;

  public getItems(): T[] {
    return this.currentItems;
  }

  public getNewItems(): T[] {
    return this.new;
  }

  public getRemovedItems(): T[] {
    return this.removed;
  }

  private isCurrentItem(item: T): boolean {
    return this.currentItems.some((v: T) => this.compareItems(item, v));
  }

  private isNewItem(item: T): boolean {
    return this.new.some((v: T) => this.compareItems(item, v));
  }

  private isRemovedItem(item: T): boolean {
    return this.removed.some((v: T) => this.compareItems(item, v));
  }

  private removeFromNew(item: T): void {
    this.new = this.new.filter((v) => !this.compareItems(v, item));
  }

  private removeFromCurrent(item: T): void {
    this.currentItems = this.currentItems.filter(
      (v) => !this.compareItems(item, v),
    );
  }

  private removeFromRemoved(item: T): void {
    this.removed = this.removed.filter((v) => !this.compareItems(item, v));
  }

  private wasAddedInitially(item: T): boolean {
    return this.initial.some((v: T) => this.compareItems(item, v));
  }

  public exists(item: T): boolean {
    return this.isCurrentItem(item);
  }

  public add(item: T): void {
    if (this.isRemovedItem(item)) {
      this.removeFromRemoved(item);
    }

    if (!this.isNewItem(item) && !this.wasAddedInitially(item)) {
      this.new.push(item);
    }

    if (!this.isCurrentItem(item)) {
      this.currentItems.push(item);
    }
  }

  public remove(item: T): void {
    this.removeFromCurrent(item);

    if (this.isNewItem(item)) {
      this.removeFromNew(item);
      return;
    }

    if (!this.isRemovedItem(item)) {
      this.removed.push(item);
    }
  }

  public update(items: T[]): void {
    const newItems = items.filter((a) => {
      return !this.getItems().some((b) => this.compareItems(a, b));
    });

    const removedItems = this.getItems().filter((a) => {
      return !items.some((b) => this.compareItems(a, b));
    });

    this.currentItems = items;
    this.new = newItems;
    this.removed = removedItems;
  }
}
```