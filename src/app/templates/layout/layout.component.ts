import { Component, OnInit } from '@angular/core';
import { ApisService } from 'src/app/services/apis/apis.service';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.less']
})
export class LayoutComponent implements OnInit {

  constructor(private apis: ApisService) {
    this.apis.getCategories();
    this.apis.getPublicBlogs();
  }

  ngOnInit(): void {
  }

}
