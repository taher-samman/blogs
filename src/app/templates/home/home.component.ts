import { DataService } from './../../services/data/data.service';
import { Component, OnInit } from '@angular/core';
import { ApisService } from 'src/app/services/apis/apis.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.less']
})
export class HomeComponent implements OnInit {
  publicBlogs:(any)[] = [];
  constructor(private apis: ApisService,private data:DataService) { 
    this.apis.getPublicBlogs();
    this.data.publicBlogs.subscribe(data => this.publicBlogs = data);
  }

  ngOnInit(): void {
  }

}
