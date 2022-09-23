import { Router } from '@angular/router';
import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, OnInit, Input } from '@angular/core';
import { DataService } from 'src/app/services/data/data.service';

@Component({
  selector: 'blog-shortcut',
  templateUrl: './shortcut.component.html',
  styleUrls: ['./shortcut.component.less']
})
export class ShortcutComponent implements OnInit {
  @Input('data') data: any;
  categories: (any)[] = [];
  currentRoute = this.router.url;
  constructor(private router:Router) {
  }

  ngOnInit(): void {
    
  }
}
