import { BehaviorSubject } from 'rxjs';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class DataService {
  categories = new BehaviorSubject([]);
  blogs = new BehaviorSubject([]);
  publicBlogs = new BehaviorSubject([]);
  blogsLikes = new BehaviorSubject([]);
  blogsComments = new BehaviorSubject([]);
  constructor() { }
}
