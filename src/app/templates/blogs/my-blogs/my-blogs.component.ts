import { Component, OnInit } from '@angular/core';
import { ApisService } from 'src/app/services/apis/apis.service';

@Component({
  selector: 'app-my-blogs',
  templateUrl: './my-blogs.component.html',
  styleUrls: ['./my-blogs.component.less']
})
export class MyBlogsComponent implements OnInit {
  blogs: (any)[];
  constructor(private apis: ApisService) {
    this.blogs = this.apis.blogs;
  }

  ngOnInit(): void {

  }

}
