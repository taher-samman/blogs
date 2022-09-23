import { DataService } from 'src/app/services/data/data.service';
import { BehaviorSubject } from 'rxjs';
import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'blog-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.less']
})
export class ToolbarComponent implements OnInit {
  @Input('id') id: number = 0;
  likes:number = 0;
  loader = new BehaviorSubject<boolean>(false);
  @Input('border') border:boolean = true;
  constructor(private data:DataService) {
   }

  ngOnInit(): void {
  }

}
