import { Component, OnInit, Input } from '@angular/core';
import { ApisService } from 'src/app/services/apis/apis.service';

@Component({
  selector: 'blogs',
  templateUrl: './blogs.component.html',
  styleUrls: ['./blogs.component.less']
})
export class BlogsComponent implements OnInit {
  categories:(any)[] = [];
  constructor(private apis: ApisService) { 
    this.categories = this.apis.categories;
  }

  ngOnInit(): void {
  }

}
