import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'blog-shortcut',
  templateUrl: './shortcut.component.html',
  styleUrls: ['./shortcut.component.less']
})
export class ShortcutComponent implements OnInit {
  @Input('data') data:any;
  constructor(private apis: ApisService) { 
  }

  ngOnInit(): void {
    this.data['cat_name'] = this.apis.categories.find( cat => cat.id = this.data.cat_id ).name;
  }

}
