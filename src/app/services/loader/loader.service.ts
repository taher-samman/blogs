import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LoaderService {
  show = new BehaviorSubject(true);
  showToolbarLoader = new BehaviorSubject(false);
  constructor() { }
}
