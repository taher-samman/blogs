import { timestamp } from 'rxjs';
import { Component, Input, OnInit } from '@angular/core';
import { Time } from '@angular/common';

@Component({
  selector: 'blog-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.less']
})
export class ProfileComponent implements OnInit {
  @Input('user') user: any;
  @Input('created_at') created_at: any;
  day: any;
  time: any;
  constructor() {

  }
  ngOnInit(): void {
    var today: any = new Date();
    var date = new Date(this.created_at);
    if (today.toDateString() !== date.toDateString()) {
      this.day = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
    }
    this.time = `${date.getHours()}:${date.getMinutes()}`;
  }
}
