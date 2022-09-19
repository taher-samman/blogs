import { LoaderService } from './../../services/loader/loader.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.less']
})
export class LoaderComponent implements OnInit {
  show:boolean;
  constructor(private loader:LoaderService) {
    this.show = this.loader.show;
   }

  ngOnInit(): void {
    this.show = this.loader.show;
  }

}
