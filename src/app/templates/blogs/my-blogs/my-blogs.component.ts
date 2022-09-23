import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, OnInit } from '@angular/core';
import { DataService } from 'src/app/services/data/data.service';

@Component({
  selector: 'app-my-blogs',
  templateUrl: './my-blogs.component.html',
  styleUrls: ['./my-blogs.component.less']
})
export class MyBlogsComponent implements OnInit {
  blogs: (any)[] = [];
  constructor(private data: DataService, private apis: ApisService) {
    this.apis.getBlogs();
    this.data.blogs.subscribe(data => this.blogs = data);
  }
  // checkKey(){
  //   if
  // }
  ngOnInit(): void {

  }

}
