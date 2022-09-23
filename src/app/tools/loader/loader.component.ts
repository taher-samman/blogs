import { LoaderService } from './../../services/loader/loader.service';
import { Component, OnInit } from '@angular/core';
import { takeUntil } from 'rxjs';

@Component({
  selector: 'app-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.less']
})
export class LoaderComponent implements OnInit {
  show:boolean = true;
  constructor(private loader:LoaderService) {
    // this.show = this.loader.show;
   }

  ngOnInit(): void {
    this.loader.show.subscribe(data => this.show = data);
  }
}