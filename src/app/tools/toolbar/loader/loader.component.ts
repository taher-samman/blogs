import { BehaviorSubject } from 'rxjs';
import { LoaderService } from './../../../services/loader/loader.service';
import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'toolbar-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.less']
})
export class LoaderToolbarComponent implements OnInit {
  show:boolean = false;
  @Input('loader') loaderSubject = new BehaviorSubject<boolean>(false);
  constructor(private loader:LoaderService) {
   }

  ngOnInit(): void {
    this.loaderSubject.subscribe(data => this.show = data);
    this.loader.showToolbarLoader.subscribe(data => this.show = data);
  }
}
