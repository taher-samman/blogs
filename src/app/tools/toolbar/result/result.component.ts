import { DataService } from 'src/app/services/data/data.service';
import { Component, Input, OnInit } from '@angular/core';
import { filter } from 'rxjs';
import { Router } from '@angular/router';
@Component({
  selector: 'toolbar-result',
  templateUrl: './result.component.html',
  styleUrls: ['./result.component.less']
})
export class ResultComponent implements OnInit {
  @Input('id') id: number = 0;
  nbComments: number = 0;
  comments: (any)[] = [];
  currentRoute = this.router.url;
  constructor(private data: DataService,private router:Router) {
    this.data.blogsComments.subscribe(data => {
      var comments = data.filter(d => d['blog_id'] === this.id)
      this.nbComments = comments.length;
      this.comments = comments;
    })
  }

  ngOnInit(): void {
  }

}
